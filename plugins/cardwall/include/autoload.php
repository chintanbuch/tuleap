<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
function autoloadf20b671c9a795d21ad581a1ae8b2cd45($class) {
    static $classes = null;
    if ($classes === null) {
        $classes = array(
            'cardcontrollerbuilderrequestdataexception' => '/CardControllerBuilderRequestDataException.class.php',
            'cardcontrollerbuilderrequestidexception' => '/CardControllerBuilderRequestIdException.class.php',
            'cardcontrollerbuilderrequestplanningidexception' => '/CardControllerBuilderRequestPlanningIdException.class.php',
            'cardresourcebadvalueformatexception' => '/CardResourceBadValueFormatException.class.php',
            'cardwall_board' => '/Board.class.php',
            'cardwall_boardpresenter' => '/BoardPresenter.class.php',
            'cardwall_cardcontroller' => '/CardController.class.php',
            'cardwall_cardfieldpresenter' => '/CardFieldPresenter.class.php',
            'cardwall_cardfields' => '/CardFields.class.php',
            'cardwall_cardincellpresenter' => '/CardInCellPresenter.class.php',
            'cardwall_cardincellpresenterbuilder' => '/CardInCellPresenterBuilder.class.php',
            'cardwall_cardincellpresenterfactory' => '/CardInCellPresenterFactory.class.php',
            'cardwall_cardincellpresenternode' => '/CardInCellPresenterNode.class.php',
            'cardwall_cardpresenter' => '/CardPresenter.class.php',
            'cardwall_column' => '/Column.class.php',
            'cardwall_effortprogresspresenter' => '/EffortProgressPresenter.class.php',
            'cardwall_fieldnotoncardexception' => '/FieldNotOnCardException.class.php',
            'cardwall_fieldproviders_customfieldretriever' => '/FieldProviders/CustomFieldProvider.class.php',
            'cardwall_fieldproviders_iprovidefieldgivenanartifact' => '/FieldProviders/IProvideFieldGivenAnArtifact.class.php',
            'cardwall_fieldproviders_semanticstatusfieldretriever' => '/FieldProviders/SemanticStatusFieldProvider.class.php',
            'cardwall_fieldsextractor' => '/FieldsExtractor.class.php',
            'cardwall_form' => '/Form.class.php',
            'cardwall_mapping' => '/Mapping.class.php',
            'cardwall_mappingcollection' => '/MappingCollection.class.php',
            'cardwall_ontop_columndao' => '/OnTop/ColumnDao.class.php',
            'cardwall_ontop_columnmappingfielddao' => '/OnTop/ColumnMappingFieldDao.class.php',
            'cardwall_ontop_columnmappingfieldvaluedao' => '/OnTop/ColumnMappingFieldValueDao.class.php',
            'cardwall_ontop_config' => '/OnTop/Config.class.php',
            'cardwall_ontop_config_columncollection' => '/OnTop/Config/ColumnCollection.class.php',
            'cardwall_ontop_config_columnfactory' => '/OnTop/Config/ColumnFactory.class.php',
            'cardwall_ontop_config_columnfreestylecollection' => '/OnTop/Config/ColumnFreestyleCollection.class.php',
            'cardwall_ontop_config_columnstatuscollection' => '/OnTop/Config/ColumnStatusCollection.class.php',
            'cardwall_ontop_config_columnsvisitor' => '/OnTop/Config/ColumnsVisitor.class.php',
            'cardwall_ontop_config_command' => '/OnTop/Config/Command.class.php',
            'cardwall_ontop_config_command_createcolumn' => '/OnTop/Config/Command/CreateColumn.class.php',
            'cardwall_ontop_config_command_createmappingfield' => '/OnTop/Config/Command/CreateMappingField.class.php',
            'cardwall_ontop_config_command_deletecolumns' => '/OnTop/Config/Command/DeleteColumns.class.php',
            'cardwall_ontop_config_command_deletemappingfields' => '/OnTop/Config/Command/DeleteMappingFields.class.php',
            'cardwall_ontop_config_command_enablecardwallontop' => '/OnTop/Config/Command/EnableCardwallOnTop.class.php',
            'cardwall_ontop_config_command_enablefreestylecolumns' => '/OnTop/Config/Command/EnableFreestyleColumns.class.php',
            'cardwall_ontop_config_command_updatecolumns' => '/OnTop/Config/Command/UpdateColumns.class.php',
            'cardwall_ontop_config_command_updatemappingfields' => '/OnTop/Config/Command/UpdateMappingFields.class.php',
            'cardwall_ontop_config_mappedfieldprovider' => '/OnTop/Config/MappedFieldProvider.class.php',
            'cardwall_ontop_config_trackermapping' => '/OnTop/Config/TrackerMapping.class.php',
            'cardwall_ontop_config_trackermappingfactory' => '/OnTop/Config/TrackerMappingFactory.class.php',
            'cardwall_ontop_config_trackermappingfield' => '/OnTop/Config/TrackerMappingField.class.php',
            'cardwall_ontop_config_trackermappingfreestyle' => '/OnTop/Config/TrackerMappingFreestyle.class.php',
            'cardwall_ontop_config_trackermappingnofield' => '/OnTop/Config/TrackerMappingNoField.class.php',
            'cardwall_ontop_config_trackermappingstatus' => '/OnTop/Config/TrackerMappingStatus.class.php',
            'cardwall_ontop_config_updater' => '/OnTop/Config/Updater.class.php',
            'cardwall_ontop_config_valuemapping' => '/OnTop/Config/ValueMapping.class.php',
            'cardwall_ontop_config_valuemappingfactory' => '/OnTop/Config/ValueMappingFactory.class.php',
            'cardwall_ontop_config_view_admin' => '/OnTop/Config/View/Admin.class.php',
            'cardwall_ontop_config_view_columndefinition' => '/OnTop/Config/View/ColumnDefinition.class.php',
            'cardwall_ontop_configempty' => '/OnTop/ConfigEmpty.class.php',
            'cardwall_ontop_configfactory' => '/OnTop/ConfigFactory.class.php',
            'cardwall_ontop_dao' => '/OnTop/Dao.class.php',
            'cardwall_ontop_iconfig' => '/OnTop/IConfig.class.php',
            'cardwall_openclosedeffortprogresspresenter' => '/OpenClosedEffortProgressPresenter.class.php',
            'cardwall_pane' => '/Pane.class.php',
            'cardwall_paneboardbuilder' => '/PaneBoardBuilder.class.php',
            'cardwall_panecontentpresenter' => '/PaneContentPresenter.class.php',
            'cardwall_rawboardbuilder' => '/RawBoardBuilder.class.php',
            'cardwall_remainingeffortprogresspresenter' => '/RemainingEffortProgressPresenter.class.php',
            'cardwall_renderer' => '/Cardwall_Renderer.class.php',
            'cardwall_rendererboardbuilder' => '/RendererBoardBuilder.class.php',
            'cardwall_rendererdao' => '/Cardwall_RendererDao.class.php',
            'cardwall_rendererpresenter' => '/RendererPresenter.class.php',
            'cardwall_rest_resourcesinjector' => '/REST/ResourcesInjector.class.php',
            'cardwall_semantic_cardfields' => '/Semantic/CardFields.class.php',
            'cardwall_semantic_cardfieldsfactory' => '/Semantic/CardFieldsFactory.class.php',
            'cardwall_semantic_dao_cardfieldsdao' => '/Semantic/Dao/CardFieldsDao.class.php',
            'cardwall_singlecard' => '/SingleCard.class.php',
            'cardwall_singlecardbuilder' => '/SingleCardBuilder.class.php',
            'cardwall_swimline' => '/Swimline.class.php',
            'cardwall_swimlinefactory' => '/SwimlineFactory.class.php',
            'cardwall_swimlinesolo' => '/SwimlineSolo.class.php',
            'cardwall_swimlinesolonomatchingcolumns' => '/SwimlineSoloNoMatchingColumns.class.php',
            'cardwall_swimlinetrackerrenderer' => '/SwimlineTrackerRenderer.class.php',
            'cardwall_userpreferences_autostack_autostackdashboard' => '/UserPreferences/Autostack/AutostackDashboard.class.php',
            'cardwall_userpreferences_autostack_autostackrenderer' => '/UserPreferences/Autostack/AutostackRenderer.class.php',
            'cardwall_userpreferences_userpreferencesautostack' => '/UserPreferences/UserPreferencesAutostack.class.php',
            'cardwall_userpreferences_userpreferencesautostackfactory' => '/UserPreferences/UserPreferencesAutostackFactory.class.php',
            'cardwall_userpreferences_userpreferencescontroller' => '/UserPreferences/UserPreferencesController.class.php',
            'cardwall_userpreferences_userpreferencesdisplayuser' => '/UserPreferences/UserPreferencesDisplayUser.class.php',
            'cardwallconfigxml' => '/CardwallConfigXml.class.php',
            'cardwallconfigxmlexport' => '/CardwallConfigXmlExport.class.php',
            'cardwallconfigxmlimport' => '/CardwallConfigXmlImport.class.php',
            'cardwallfromxmlimportcannotbeenabledexception' => '/CardwallFromXmlImportCannotBeEnabledException.class.php',
            'cardwallplugin' => '/cardwallPlugin.class.php',
            'cardwallplugindescriptor' => '/CardwallPluginDescriptor.class.php',
            'cardwallplugininfo' => '/CardwallPluginInfo.class.php',
            'initialeffortnotdefinedexception' => '/InitialEffortNotDefinedException.class.php',
            'tuleap\\cardwall\\agiledashboard\\cardwallpaneinfo' => '/Cardwall/Agiledashboard/PaneInfo.php',
            'tuleap\\cardwall\\rest\\v1\\cardsresource' => '/REST/v1/CardsResource.class.php',
            'tuleap\\cardwall\\rest\\v1\\cardupdater' => '/REST/v1/CardUpdater.class.php',
            'tuleap\\cardwall\\rest\\v1\\cardvalidator' => '/REST/v1/CardValidator.php',
            'tuleap\\cardwall\\rest\\v1\\milestonescardwallresource' => '/REST/v1/MilestonesCardwallResource.class.php',
            'tuleap\\cardwall\\semantic\\backgroundcolordao' => '/Semantic/BackgroundColorDao.php',
            'tuleap\\cardwall\\semantic\\backgroundcolorfieldsaver' => '/Semantic/BackgroundColorFieldSaver.php',
            'tuleap\\cardwall\\semantic\\backgroundcolorpresenterbuilder' => '/Semantic/BackgroundColorPresenterBuilder.php',
            'tuleap\\cardwall\\semantic\\backgroundcolorselectorpresenter' => '/Semantic/BackgroundColorSelectorPresenter.php',
            'tuleap\\cardwall\\semantic\\cardfieldspresenterbuilder' => '/Semantic/CardFieldsPresenterBuilder.php',
            'tuleap\\cardwall\\semantic\\cardfieldxmlextractor' => '/Semantic/CardFieldXmlExtractor.php',
            'tuleap\\cardwall\\semantic\\fieldpresenter' => '/Semantic/FieldPresenter.php',
            'tuleap\\cardwall\\semantic\\fieldusedinsemanticobjectchecker' => '/Semantic/FieldUsedInSemanticObjectChecker.php',
            'tuleap\\cardwall\\semantic\\semanticcardpresenter' => '/Semantic/SemanticCardPresenter.php'
        );
    }
    $cn = strtolower($class);
    if (isset($classes[$cn])) {
        require dirname(__FILE__) . $classes[$cn];
    }
}
spl_autoload_register('autoloadf20b671c9a795d21ad581a1ae8b2cd45');
// @codeCoverageIgnoreEnd
